import {RouteComponentProps} from "@reach/router";
import {Challenge, DefaultApi} from "../gen";

export interface SavedChallengeProps extends RouteComponentProps {
    api: DefaultApi,
    uuid?: string
}

export interface NewChallengeProps extends RouteComponentProps {
    api: DefaultApi,
    challenge: Challenge
}
