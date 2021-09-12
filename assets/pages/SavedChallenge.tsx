import Title from "../components/Title";
import * as React from "react";
import {Fragment, useEffect, useState} from "react";
import {DefaultApi, SavedChallengeDetails} from "../gen";
import {default as ComponentSavedChallenge} from "../components/SavedChallenge";
import {useParams} from "react-router";

interface SavedChallengeProps{
    api: DefaultApi
}

const SavedChallenge = ({api}: SavedChallengeProps) => {
    const {uuid} = useParams<{ uuid?: string }>();
    const [result, setResult] = useState<SavedChallengeDetails | null>(null);
    useEffect(() => {
        let mount = true
        if (!result && uuid) {
            api.challengeUuidResultsGet(uuid).then(res => {
                if (mount) {
                    setResult(res);
                }

            })
        }
        return () => {
            mount = false
        }
    }, []);
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