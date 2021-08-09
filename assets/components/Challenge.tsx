import * as React from 'react';
import {Fragment} from 'react'
import {useEffect, useState} from 'react';
import {DefaultApi} from "../gen";
import Randomizer from "./Randomizer";

type ChallengeProps = {
    id: number,
    api: DefaultApi
}

const Challenge = ({id, api}: ChallengeProps) => {
    const [randomizerList, setRandomizerList] = useState<Array<string> | null>(null);
    useEffect(() => {
        if (!randomizerList && id !== 0) {
            api.challengeIdGet(id).then(challenge => {
                setRandomizerList(challenge.randomizers);
            })
        }
        return () => {}
    });
    if (randomizerList) {
        return (
            <Fragment>
                <ul>
                    {randomizerList.map(item => <Randomizer key={item} name={item} api={api}/>)}
                </ul>
                <button onClick={() => setRandomizerList(null)}>Refresh</button>
            </Fragment>
        );
    } else {
        return <div>Please Choose</div>;
    }
}

export default Challenge