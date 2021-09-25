import * as React from "react";
import List from '@mui/material/List';
import { makeStyles } from '@mui/styles';
import {RandomizerResult} from "../gen";
import RandomizerListItem from "./RandomizerListItem";

type SavedChallengeProps = {
    randomizers: Array<RandomizerResult>
}

const useStyles = makeStyles((theme?: any) => ({
    root: {
        width: '100%',
        backgroundColor: theme.palette.background.paper,
    }
}));

const SavedChallenge = ({randomizers}: SavedChallengeProps) => {
    const classes = useStyles();
    return (
        <div>
            <List className={classes.root}>
                {randomizers.map(rando => {
                       return <RandomizerListItem key={rando.id} name={rando.title} result={rando.result}/>
                    }
                )}
            </List>
        </div>
    )
}

export default SavedChallenge;