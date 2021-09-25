import * as React from 'react';
import {createRef, Fragment, RefObject} from 'react'
import {useEffect, useState} from 'react';
import {DefaultApi, RandomizerResult} from "../gen";
import Randomizer from "./Randomizer";
import RandomizerListItem from "./RandomizerListItem";
import { makeStyles } from '@mui/styles';
import List from '@mui/material/List';
import ShareChallengeBox from "./ShareChallengeBox";
import IconButton from "@mui/material/IconButton";
import CasinoIcon from '@mui/icons-material/Casino';
import ShareIcon from '@mui/icons-material/Share';

type ChallengeProps = {
    id: number,
    name: string,
    count: number,
    api: DefaultApi
}

const useStyles = makeStyles((theme?: any) => ({
    root: {
        width: '100%',
        backgroundColor: theme.palette.background.paper,
    },
    iconButtonsBar: {
        display: "flex",
        flexDirection: "row",
        justifyContent: "space-between",
        paddingLeft: "16px",
        paddingRight: "16px",
    }
}));

const Challenge = ({id, name, count, api}: ChallengeProps) => {
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
    const [randomizerListCount, setRandomizerListCount] = useState<number>(count);
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
    }, [count, randomizerList]);

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
                <div className={classes.iconButtonsBar}>
                    <IconButton aria-label="Refresh" onClick={() => setRandomizerList(null)} size="large">
                        <CasinoIcon/>
                    </IconButton>
                    <IconButton aria-label="Share" onClick={() => setOpen(true)} size="large">
                        <ShareIcon/>
                    </IconButton>
                </div>
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
                <div className={classes.iconButtonsBar}>
                    <IconButton aria-label="Refresh" disabled size="large">
                        <CasinoIcon/>
                    </IconButton>
                    <IconButton aria-label="Share" disabled size="large">
                        <ShareIcon/>
                    </IconButton>
                </div>
            </Fragment>
        );
    }
}

export default Challenge