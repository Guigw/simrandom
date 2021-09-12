import * as React from "react";
import {Redirect} from "react-router";

const Home = () => {
    return (
        <Redirect to={"/randomize/challenge/construction"}/>
    )
}
export default Home;
