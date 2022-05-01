import * as React from "react";
import List from '@mui/material/List';
import {RandomizerResult} from "../../gen";
import RandomizerListItem from "../RandomizerListItem/RandomizerListItem";
import {styled} from "@mui/material";

type SavedChallengeProps = {
    randomizers: Array<RandomizerResult>
}
const MyList = styled(List)(({theme}) => ({
    width: '100%',
    backgroundColor: theme.palette.background.paper,
}))

const SavedChallenge = ({randomizers}: SavedChallengeProps) => {
    return (
        <div>
            <MyList>
                {randomizers.map(rando => {
                        return <RandomizerListItem key={rando.id} name={rando.title} result={rando.result}/>
                    }
                )}
            </MyList>
        </div>
    )
}

export default SavedChallenge;