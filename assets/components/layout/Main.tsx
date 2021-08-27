import Container from "@material-ui/core/Container";
import Grid from "@material-ui/core/Grid";
import Paper from "@material-ui/core/Paper";
import {RouteComponentProps, Router} from "@reach/router";
import NewChallenge from "../../pages/NewChallenge";
import SavedChallenge from "../../pages/SavedChallenge";
import Box from "@material-ui/core/Box";
import Licence from "./Licence";
import * as React from "react";
import {makeStyles} from "@material-ui/core/styles";
import {DefaultApi, Challenge} from "../../gen";

const useStyles = makeStyles((theme) => ({
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

const Main = ({api, challenge}: MainProps) => {
    const classes = useStyles();
    return (
        <main className={classes.content}>
            <div className={classes.appBarSpacer}/>
            <Container maxWidth="lg" className={classes.container}>
                <Grid container spacing={3}>
                    {/* Recent Orders */}
                    <Grid item xs={12}>
                        <Paper className={classes.paper}>
                            <Router>
                                <NewChallenge api={api} challenge={challenge} path="/"/>
                                <SavedChallenge api={api} path="challenge/:uuid"/>
                            </Router>
                        </Paper>
                    </Grid>
                </Grid>
                <Box pt={4}>
                    <Licence/>
                </Box>
            </Container>
        </main>
    )
}
export default Main;