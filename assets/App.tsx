import * as React from 'react';
import clsx from 'clsx';
import {makeStyles} from '@material-ui/core/styles';
import CssBaseline from '@material-ui/core/CssBaseline';
import AppBar from '@material-ui/core/AppBar';
import Toolbar from '@material-ui/core/Toolbar';
import Typography from '@material-ui/core/Typography';
import IconButton from '@material-ui/core/IconButton';
import MenuIcon from '@material-ui/icons/Menu';
import useMediaQuery from '@material-ui/core/useMediaQuery';
import {createTheme, ThemeProvider} from '@material-ui/core/styles';
import "./style/App.less";
import {Challenge, createConfiguration, DefaultApi} from "./gen";
import Main from "./components/layout/Main";
import AppDrawer from "./components/layout/AppDrawer";
import {Fragment, useEffect, useState} from "react";
import {Router} from "@reach/router";


const drawerWidth = 240;

const useStyles = makeStyles((theme) => ({
    root: {
        display: 'flex',
        '& >div:last-child': {
            width: "100%"
        }
    },
    toolbar: {
        paddingRight: 24, // keep right padding when drawer closed
    },
    appBar: {
        zIndex: theme.zIndex.drawer + 1,
        transition: theme.transitions.create(['width', 'margin'], {
            easing: theme.transitions.easing.sharp,
            duration: theme.transitions.duration.leavingScreen,
        }),
    },
    appBarShift: {
        marginLeft: drawerWidth,
        width: `calc(100% - ${drawerWidth}px)`,
        transition: theme.transitions.create(['width', 'margin'], {
            easing: theme.transitions.easing.sharp,
            duration: theme.transitions.duration.enteringScreen,
        }),
    },
    menuButton: {
        marginRight: 36,
    },
    menuButtonHidden: {
        display: 'none',
    },
    title: {
        flexGrow: 1,
    },

    fixedHeight: {
        height: 240,
    },
}));

export default function App() {
    const conf = createConfiguration();
    const api = new DefaultApi(conf);
    const classes = useStyles();
    const [open, setOpen] = React.useState<boolean>(false);
    const [selectedChallenge, setSelectedChallenge] = React.useState<Challenge>({id: 0, name: "", count: 0});
    const [list, setList] = useState<Array<Challenge>>([]);
    useEffect(() => {
        let mount = true;
        if (list.length === 0) {
            api.challengeGet().then(items => {
                if (mount) {
                    setList(items);
                    onSelect(items[0].id, items[0].name, items[0].count)
                }
            })
        }
        return () => {
            mount = false
        }
    }, []);
    const handleDrawerOpen = () => {
        setOpen(true);
    };
    const handleDrawerClose = () => {
        setOpen(false);
    };
    const onSelect = (id: number, name: string, count: number) => {
        if (selectedChallenge.id !== id) {
            setSelectedChallenge({id, name, count});
        }
    }
    const prefersDarkMode = useMediaQuery('(prefers-color-scheme: dark)');

    const theme = React.useMemo(
        () =>
            createTheme({
                palette: {
                    type: prefersDarkMode ? 'dark' : 'light',
                },
            }),
        [prefersDarkMode],
    );

    // const Appp = React.memo((props: any) => {
    //     console.log('render Appp');
    //     return (
    //     <Fragment>
    //         {props.children}
    //     </Fragment>
    // )}, (prevProps, nextProps) => {
    //     // Comment below is from React documentation.
    //     /*
    //      return true if passing nextProps to render would return
    //      the same result as passing prevProps to render,
    //      otherwise return false
    //     */
    //     return true;
    // });


    return (
        <ThemeProvider theme={theme}>
            <div className={classes.root}>
                <CssBaseline/>
                <AppBar position="absolute" className={clsx(classes.appBar, open && classes.appBarShift)}>
                    <Toolbar className={classes.toolbar}>
                        <IconButton
                            edge="start"
                            color="inherit"
                            aria-label="open drawer"
                            onClick={handleDrawerOpen}
                            className={clsx(classes.menuButton, open && classes.menuButtonHidden)}
                        >
                            <MenuIcon/>
                        </IconButton>
                        <Typography component="h1" variant="h6" color="inherit" noWrap className={classes.title}>
                            Sims Randomizer
                        </Typography>
                    </Toolbar>
                </AppBar>
                <AppDrawer open={open} handleDrawerClose={handleDrawerClose} list={list} onSelect={onSelect}/>
                <Main api={api} challenge={selectedChallenge}/>
            </div>
        </ThemeProvider>
    );
}