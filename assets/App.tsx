import * as React from 'react';
import {Component, Fragment} from 'react'
import "./style/App.less";
import ChallengeSelector from './components/ChallengeSelector';

class App extends Component<{}, {}>{
    render(){
        return(
            <Fragment>
                <h1> Sims Randomizer </h1>
                <ChallengeSelector/>
            </Fragment>
        );
    }
}

export default App;