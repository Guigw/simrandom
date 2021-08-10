import * as React from 'react';
import {createRef, Fragment, MutableRefObject, RefObject} from 'react'
import {useEffect, useState} from 'react';
import {DefaultApi} from "../gen";
import Randomizer from "./Randomizer";

type ChallengeProps = {
    id: number,
    api: DefaultApi
}

const Challenge = ({id, api}: ChallengeProps) => {
    interface ResultsArray {
        [index: string]: string;
    }

    interface DependencyArray {
        [index: string]: string;
    }

    interface RandomizerValues {
        name: string,
        ref: RefObject<any>
    }

    let results: ResultsArray = {};
    let dependencies: DependencyArray = {};


    const [randomizerList, setRandomizerList] = useState<Array<RandomizerValues> | null>(null);
    useEffect(() => {
        if (!randomizerList && id !== 0) {
            api.challengeIdGet(id).then(challenge => {
                setRandomizerList(challenge.randomizers.map(function (item: string) {
                    return {name: item, ref: createRef()}
                }));
            })
        }
        return () => {
        }
    });

    const requirement = (from: string, to: string) => {
        dependencies[to] = from;
        if (results[to]) {
            return results[to];
        } else {
            return "";
        }
    }

    const onResult = (name: string, result: string) => {
        results[name] = result;
        //si on a une dépendance sur le randomizer
        if (dependencies[name]) {
            //on cherche la ref
            const foundRef = randomizerList.filter(function(item: RandomizerValues){
               return item.name === dependencies[name];
            });
            if (foundRef.length){
                foundRef[0].ref.current.resetResult();
            }
        }
    }

    if (randomizerList) {
        return (
            <Fragment>
                <ul>
                    {randomizerList.map(item => <Randomizer ref={item.ref} key={item.name} name={item.name} api={api} onResult={onResult}
                                                            needRequirement={requirement}/>)}
                </ul>
                <button onClick={() => setRandomizerList(null)}>Refresh</button>
            </Fragment>
        );
    } else {
        return <div>Please Choose</div>;
    }
}

export default Challenge