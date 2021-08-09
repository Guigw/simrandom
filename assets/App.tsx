import * as React from 'react';
import {Component, Fragment} from 'react'
import "./style/App.less";
import ChallengeSelector from './components/ChallengeSelector';
import Challenge from './components/Challenge';
import {createConfiguration, DefaultApi} from "./gen";


type AppState = {
    selectedChallenge: number
}

class App extends Component<{}, AppState> {
    private conf = createConfiguration();
    private api = new DefaultApi(this.conf);
    state: AppState = {
        selectedChallenge: 0,
    };

    onSelect = (challenge: string) => {
        this.setState({selectedChallenge: parseInt(challenge)})
    }

    render() {
        return (
            <Fragment>
                <h1> Sims Randomizer </h1>
                <ChallengeSelector api={this.api} onSelect={this.onSelect}/>
                <Challenge id={this.state.selectedChallenge} api={this.api}/>
            </Fragment>
        );
    }
}

export default App;