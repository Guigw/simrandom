import Title from "../components/Title";
import {default as ChallengeComponent} from "../components/Challenge";
import * as React from "react";
import {Challenge, DefaultApi} from "../gen";
import {useParams} from "react-router";

interface NewChallengeProps {
    api: DefaultApi,
    challenge: Challenge
}

const NewChallenge = ({api, challenge}: NewChallengeProps) => {
    const {name} = useParams<{ name?: string }>();
    return (
        <React.Fragment>
            <Title> {challenge.name} </Title>
            <ChallengeComponent id={challenge.id} name={challenge.name} count={challenge.count} api={api}/>
        </React.Fragment>
    )
}
export default NewChallenge