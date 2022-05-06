import Title from "../components/Title/Title";
import {default as ChallengeComponent} from "../components/Challenge/Challenge";
import * as React from "react";
import {Challenge, DefaultApi} from "../gen";

interface NewChallengeProps {
    api: DefaultApi,
    challenge: Challenge
}

const NewChallenge = ({api, challenge}: NewChallengeProps) => {
    return (
        <React.Fragment>
            <Title> {challenge.name} </Title>
            <ChallengeComponent id={challenge.id} name={challenge.name} count={challenge.count} api={api}/>
        </React.Fragment>
    )
}
export default NewChallenge