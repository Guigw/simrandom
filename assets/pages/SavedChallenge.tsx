import Title from "../components/Title";
import * as React from "react";
import {SavedChallengeProps} from "../interfaces/RouteProps";
import {Fragment, useEffect, useState} from "react";
import {SavedChallengeDetails} from "../gen";
import {default as ComponentSavedChallenge} from "../components/SavedChallenge";


const SavedChallenge = ({api, uuid}: SavedChallengeProps) => {
    const [result, setResult] = useState<SavedChallengeDetails | null>(null);
    useEffect(() => {
        if (!result) {
            api.challengeUuidResultsGet(uuid).then(res => {
                setResult(res);
            })
        }
        return () => {
        }
    });
    return (
        <React.Fragment>
            {result &&
                <Fragment>
                    <Title>{result.name}</Title>
                    <ComponentSavedChallenge randomizers={result.randomizers}/>
                </Fragment>
            }
        </React.Fragment>
    )
}

export default SavedChallenge;