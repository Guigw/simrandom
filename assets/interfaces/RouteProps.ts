import {RouteComponentProps} from "@reach/router";
import {DefaultApi} from "../gen";
import challengeState from "./challengeState";

export interface SavedChallengeProps extends RouteComponentProps {
    api: DefaultApi,
    uuid?: string
}

export interface NewChallengeProps extends RouteComponentProps {
    api: DefaultApi,
    challenge: challengeState
}
