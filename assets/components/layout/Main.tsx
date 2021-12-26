import Container from "@mui/material/Container";
import Grid from "@mui/material/Grid";
import Paper from "@mui/material/Paper";
import NewChallenge from "../../pages/NewChallenge";
import SavedChallenge from "../../pages/SavedChallenge";
import Home from "../../pages/Home";
import Box from "@mui/material/Box";
import Licence from "./Licence";
import * as React from "react";
import {Challenge, DefaultApi} from "../../gen";
import {Route, Switch} from "react-router";
import {styled, useTheme} from "@mui/material";

const MainContainer = styled('main')({
    flexGrow: 1,
    height: '100vh',
    overflow: 'auto',
})

const SubContainer = styled(Container)(({theme}) => ({
    paddingTop: theme.spacing(4),
    paddingBottom: theme.spacing(4),
}))

const StyledPaper = styled(Paper)(({theme}) => ({
    padding: theme.spacing(2),
    display: 'flex',
    overflow: 'auto',
    flexDirection: 'column',
}))

interface MainProps {
    api: DefaultApi,
    challenge: Challenge,
}

const Main = React.memo<MainProps>(({api, challenge}: MainProps) => {
    const theme = useTheme();
    return (
        <MainContainer>
            <Box sx={theme.mixins.toolbar}/>
            <SubContainer maxWidth="lg">
                <Grid container spacing={3}>
                    {/* Recent Orders */}
                    <Grid item xs={12}>
                        <StyledPaper>
                            <Switch>
                                <Route exact path="/"
                                       component={() => <Home/>}/>
                                <Route path="/randomize/challenge/:name"
                                       component={() => <NewChallenge api={api} challenge={challenge}/>}/>
                                <Route path="/challenge/:uuid" component={() => <SavedChallenge api={api}/>}/>
                            </Switch>
                        </StyledPaper>
                    </Grid>
                </Grid>
                <Box pt={4}>
                    <Licence/>
                </Box>
            </SubContainer>
        </MainContainer>
    )
}, (prevProps, nextProps) => {
    return prevProps.challenge.id === nextProps.challenge.id;
})
export default Main;