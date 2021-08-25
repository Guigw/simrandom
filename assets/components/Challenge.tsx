import * as React from 'react';
import {createRef, Fragment, RefObject} from 'react'
import {useEffect, useState} from 'react';
import {DefaultApi, RandomizerResult} from "../gen";
import Randomizer from "./Randomizer";
import RandomizerListItem from "./RandomizerListItem";
import {Button} from "@material-ui/core";
import {makeStyles} from '@material-ui/core/styles';
import List from '@material-ui/core/List';
import ShareChallengeBox from "./ShareChallengeBox";

type ChallengeProps = {
    id: number,
    name: string,
    randomizerCount: number,
    api: DefaultApi
}

const useStyles = makeStyles((theme) => ({
    root: {
        width: '100%',
        backgroundColor: theme.palette.background.paper,
    }
}));

const Challenge = ({id, name, randomizerCount, api}: ChallengeProps) => {
    interface childrenStateArray {
        [index: string]: childrenState;
    }

    interface DependencyArray {
        [index: string]: string;
    }

    interface childrenState {
        id?: number,
        result?: string,
        active?: boolean
    }

    interface RandomizerValues {
        name: string,
        ref: RefObject<any>
    }

    let childrenStates: childrenStateArray = {};
    let dependencies: DependencyArray = {};

    const classes = useStyles();
    const [randomizerList, setRandomizerList] = useState<Array<RandomizerValues> | null>(null);
    const [randomizerListCount, setRandomizerListCount] = useState<number>(randomizerCount);
    const [open, setOpen] = React.useState(false);

    useEffect(() => {
        if (!randomizerList && id !== 0) {
            api.challengeIdGet(id).then(challenge => {
                if (randomizerListCount !== challenge.randomizers.length) {
                    setRandomizerListCount(challenge.randomizers.length);
                }
                setRandomizerList(challenge.randomizers.map(function (item: string) {
                    return {name: item, ref: createRef()}
                }));
            })
        }
        return () => {
        }
    }, [randomizerCount, randomizerList]);

    const requirement = (from: string, to: string) => {
        dependencies[to] = from;
        if (childrenStates[to]) {
            return childrenStates[to].result;
        } else {
            return "";
        }
    }

    const onToggle = (name: string, active: boolean) => {
        if (childrenStates[name]) {
            childrenStates[name]['active'] = active;
        } else {
            childrenStates[name] = {active};
        }
    }

    const onResult = (result: RandomizerResult) => {
        if (!childrenStates[result.title]) {
            childrenStates[result.title] = {};
        }
        childrenStates[result.title]['result'] = result.result;
        childrenStates[result.title]['id'] = result.id;


        //si on a une dépendance sur le randomizer
        if (dependencies[result.title]) {
            //cherchez la ref
            const foundRef = randomizerList.filter(function (item: RandomizerValues) {
                return item.name === dependencies[result.title];
            });
            if (foundRef.length) {
                foundRef[0].ref.current.resetResult();
            }
        }
    }

    const getResultChallenge = () => {
        return ({
            name, resultList: randomizerList.map(item => {
                return item.ref.current.getResult().id;
            })
        })
    }

    if (randomizerList) {
        return (
            <Fragment>
                <List className={classes.root}>
                    {randomizerList.map(item => <Randomizer ref={item.ref}
                                                            activeProps={((Object.keys(childrenStates).length > 0 && typeof childrenStates[item.name].active !== undefined) ? childrenStates[item.name].active : true)}
                                                            key={item.name} name={item.name} api={api}
                                                            onResult={onResult}
                                                            onToggle={onToggle} needRequirement={requirement}/>)}
                </List>
                <Button color={'primary'} onClick={() => setRandomizerList(null)}>Refresh</Button>
                <Button color={'primary'} onClick={() => setOpen(true)}>Share</Button>
                <ShareChallengeBox open={open} api={api} onClose={() => setOpen(false)}
                                   getResultChallenge={getResultChallenge}/>
            </Fragment>
        );
    } else {
        const rows = [];
        for (let i = 0; i < randomizerListCount; i++) {
            rows.push(<RandomizerListItem key={i} name={i.toString()} skeleton={true}/>);
        }
        return (
            <Fragment>
                <List className={classes.root}>
                    {rows}
                </List>
                <Button color={'secondary'}>Refresh</Button>
                <Button color={'secondary'}>Share</Button>
            </Fragment>
        )
    }
}

export default Challenge