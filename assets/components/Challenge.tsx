import * as React from 'react';
import {createRef, Fragment, MutableRefObject, RefObject} from 'react'
import {useEffect, useState} from 'react';
import {DefaultApi} from "../gen";
import Randomizer from "./Randomizer";
import {Button} from "@material-ui/core";
import Skeleton from '@material-ui/lab/Skeleton';
import {makeStyles} from '@material-ui/core/styles';
import List from '@material-ui/core/List';
import ListItem from '@material-ui/core/ListItem';

type ChallengeProps = {
    id: number,
    api: DefaultApi
}

const useStyles = makeStyles((theme) => ({
    root: {
        width: '100%',
        backgroundColor: theme.palette.background.paper,
    },
    skeletonContainer: {
        display: "flex",
    },
    skeletonTop: {
        marginRight: "42px",
        flexShrink: 0,
    },
    skeletonMid: {
        flex: "max-content",
        marginRight: "42px",
    }
}));

const Challenge = ({id, api}: ChallengeProps) => {
    interface childrenStateArray {
        [index: string]: childrenState;
    }

    interface DependencyArray {
        [index: string]: string;
    }

    interface childrenState {
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
    const [randomizerListCount, setRandomizerListCount] = useState<number>(5);
    useEffect(() => {
        if (!randomizerList && id !== 0) {
            api.challengeIdGet(id).then(challenge => {
                setRandomizerListCount(challenge.randomizers.length);
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

    const onResult = (name: string, result: string) => {
        if (childrenStates[name]) {
            childrenStates[name]['result'] = result;
        } else {
            childrenStates[name] = {result};
        }
        //si on a une dépendance sur le randomizer
        if (dependencies[name]) {
            //on cherche la ref
            const foundRef = randomizerList.filter(function (item: RandomizerValues) {
                return item.name === dependencies[name];
            });
            if (foundRef.length) {
                foundRef[0].ref.current.resetResult();
            }
        }
    }


    if (randomizerList) {
        return (
            <Fragment>
                <List className={classes.root}>
                    {randomizerList.map(item => <Randomizer ref={item.ref}
                                                            activeProps={(childrenStates[item.name] && typeof childrenStates[item.name].active !== undefined) ? childrenStates[item.name].active : true}
                                                            key={item.name} name={item.name} api={api}
                                                            onResult={onResult}
                                                            onToggle={onToggle} needRequirement={requirement}/>)}
                </List>
                <Button color={'primary'} onClick={() => setRandomizerList(null)}>Refresh</Button>
            </Fragment>
        );
    } else {
        const rows = [];
        for (let i = 0; i < randomizerListCount; i++) {
            rows.push(<ListItem key={i} role={undefined} dense button className={classes.skeletonContainer}>
                <Skeleton className={classes.skeletonTop} variant="rect" width={24} height={24}/>
                <Skeleton className={classes.skeletonMid} variant="rect" height={52}/>
                <Skeleton variant="circle" width={36} height={36}/>
            </ListItem>);
        }
        return (
            <List className={classes.root}>
                {rows}
            </List>
        )
    }
}

export default Challenge