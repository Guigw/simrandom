import Title from "../components/Title";
import Challenge from "../components/Challenge";
import * as React from "react";
import {NewChallengeProps} from "../interfaces/RouteProps";

const NewChallenge = ({api, challenge}: NewChallengeProps) => {
    return (
        <React.Fragment>
            <Title> {challenge.name} </Title>
            <Challenge id={challenge.id} name={challenge.name} randomizerCount={challenge.count} api={api}/>
        </React.Fragment>
    )
}

export default NewChallenge;