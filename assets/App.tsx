import * as React from 'react';
import {useEffect, useState} from 'react';
import clsx from 'clsx';
import {makeStyles} from '@mui/styles';
import CssBaseline from '@mui/material/CssBaseline';
import AppBar from '@mui/material/AppBar';
import Toolbar from '@mui/material/Toolbar';
import Typography from '@mui/material/Typography';
import IconButton from '@mui/material/IconButton';
import MenuIcon from '@mui/icons-material/Menu';
import {createTheme, StyledEngineProvider, Theme, ThemeProvider} from '@mui/material/styles';
import "./style/App.less";
import {Challenge, createConfiguration, DefaultApi} from "./gen";
import Main from "./components/layout/Main";
import AppDrawer from "./components/layout/AppDrawer";
import {BrowserRouter} from "react-router-dom";
import {PaletteMode, useMediaQuery} from "@mui/material";
import {green, grey, lightGreen} from '@mui/material/colors';


declare module '@mui/styles/defaultTheme' {
    // eslint-disable-next-line @typescript-eslint/no-empty-interface
    interface DefaultTheme extends Theme {

    }
}

const drawerWidth = 240;

const useStyles = makeStyles((theme?: any) => ({
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
        backgroundColor: theme.palette.primary[700]
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

const getDesignTokens = (mode: PaletteMode) => ({
    palette: {
        mode,
        ...(mode === 'light'
            ? {
                // palette values for light mode
                primary: green,
                divider: green[200],
                text: {
                    primary: grey[900],
                    secondary: grey[800],
                },
            }
            : {
                // palette values for dark mode
                primary: lightGreen,
                divider: lightGreen[200],
            }),
    },
});

const Root = () => {
    const classes = useStyles();
    const conf = createConfiguration();
    const api = new DefaultApi(conf);
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
    return (
        <div className={classes.root}>
            <BrowserRouter>
                <AppBar position="absolute" className={clsx(classes.appBar, open && classes.appBarShift)}>
                    <Toolbar className={classes.toolbar}>
                        <IconButton
                            edge="start"
                            color="inherit"
                            aria-label="open drawer"
                            onClick={handleDrawerOpen}
                            className={clsx(classes.menuButton, open && classes.menuButtonHidden)}
                            size="large">
                            <MenuIcon/>
                        </IconButton>
                        <Typography component="h1" variant="h6" color="inherit" noWrap className={classes.title}>
                            Sims Randomizer
                        </Typography>
                    </Toolbar>
                </AppBar>
                <AppDrawer open={open} handleDrawerClose={handleDrawerClose} list={list} onSelect={onSelect}/>
                <Main api={api} challenge={selectedChallenge}/>
            </BrowserRouter>
        </div>
    );
}

export default function App() {
    const prefersDarkMode = useMediaQuery('(prefers-color-scheme: dark)');
    const theme = React.useMemo(
        () =>
            createTheme(getDesignTokens(prefersDarkMode ? 'dark' : 'light')),
        [prefersDarkMode],
    );
    return (
        <StyledEngineProvider injectFirst>
            <ThemeProvider theme={theme}>
                <CssBaseline/>
                <Root/>
            </ThemeProvider>
        </StyledEngineProvider>
    );
}