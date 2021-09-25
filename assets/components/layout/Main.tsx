import Container from "@mui/material/Container";
import Grid from "@mui/material/Grid";
import Paper from "@mui/material/Paper";
import NewChallenge from "../../pages/NewChallenge";
import SavedChallenge from "../../pages/SavedChallenge";
import Home from "../../pages/Home";
import Box from "@mui/material/Box";
import Licence from "./Licence";
import * as React from "react";
import { makeStyles } from '@mui/styles';
import {DefaultApi, Challenge} from "../../gen";
import {Route, Switch} from "react-router";

const useStyles = makeStyles((theme?: any) => ({
    appBarSpacer: theme.mixins.toolbar,
    content: {
        flexGrow: 1,
        height: '100vh',
        overflow: 'auto',
    },
    container: {
        paddingTop: theme.spacing(4),
        paddingBottom: theme.spacing(4),
    },
    paper: {
        padding: theme.spacing(2),
        display: 'flex',
        overflow: 'auto',
        flexDirection: 'column',
    },
}));

interface MainProps {
    api: DefaultApi,
    challenge: Challenge,
}

const Main = React.memo<MainProps>(({api, challenge}: MainProps) => {
    const classes = useStyles();
    return (
        <main className={classes.content}>
            <div className={classes.appBarSpacer}/>
            <Container maxWidth="lg" className={classes.container}>
                <Grid container spacing={3}>
                    {/* Recent Orders */}
                    <Grid item xs={12}>
                        <Paper className={classes.paper}>
                            <Switch>
                                <Route exact path="/"
                                       component={() => <Home/>}/>
                                <Route path="/randomize/challenge/:name"
                                       component={() => <NewChallenge api={api} challenge={challenge}/>}/>
                                <Route path="/challenge/:uuid" component={() => <SavedChallenge api={api}/>}/>
                            </Switch>
                        </Paper>
                    </Grid>
                </Grid>
                <Box pt={4}>
                    <Licence/>
                </Box>
            </Container>
        </main>
    )
}, (prevProps, nextProps) => {
    return prevProps.challenge.id === nextProps.challenge.id;
})
export default Main;