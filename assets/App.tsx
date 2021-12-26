import * as React from 'react';
import {useEffect, useState} from 'react';
import CssBaseline from '@mui/material/CssBaseline';
import MuiAppBar, {AppBarProps as MuiAppBarProps} from '@mui/material/AppBar';
import Toolbar from '@mui/material/Toolbar';
import Typography from '@mui/material/Typography';
import IconButton from '@mui/material/IconButton';
import MenuIcon from '@mui/icons-material/Menu';
import {ThemeProvider} from '@mui/material/styles';
import {Challenge, createConfiguration, DefaultApi} from "./gen";
import Main from "./components/layout/Main";
import AppDrawer from "./components/layout/AppDrawer";
import {BrowserRouter} from "react-router-dom";
import {styled, useMediaQuery} from "@mui/material";
import importedTheme from "./style/theme";

const drawerWidth: number = 240;

const Container = styled('div')({
    display: 'flex',
    '& >div:last-child': {
        width: "100%"
    }
})

interface AppBarProps extends MuiAppBarProps {
    open?: boolean;
}

const AppBar = styled(MuiAppBar, {
    shouldForwardProp: (prop) => prop !== 'open',
})<AppBarProps>(({theme, open}) => ({
    zIndex: theme.zIndex.drawer + 1,
    transition: theme.transitions.create(['width', 'margin'], {
        easing: theme.transitions.easing.sharp,
        duration: theme.transitions.duration.leavingScreen,
    }),
    ...(open && {
        marginLeft: drawerWidth,
        width: `calc(100% - ${drawerWidth}px)`,
        transition: theme.transitions.create(['width', 'margin'], {
            easing: theme.transitions.easing.sharp,
            duration: theme.transitions.duration.enteringScreen,
        }),
    }),
}));

const Root = () => {
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
        <Container>
            <BrowserRouter>
                <AppBar position="absolute" open={open}>
                    <Toolbar sx={{pr: '24px'}}>
                        <IconButton
                            edge="start"
                            color="inherit"
                            aria-label="open drawer"
                            onClick={handleDrawerOpen}
                            sx={{
                                marginRight: '36px',
                                ...(open && {display: 'none'}),
                            }}>
                            <MenuIcon/>
                        </IconButton>
                        <Typography sx={{flexGrow: 1}} component="h1" variant="h6" color="inherit" noWrap>
                            Sims Randomizer
                        </Typography>
                    </Toolbar>
                </AppBar>
                <AppDrawer open={open} handleDrawerClose={handleDrawerClose} list={list} onSelect={onSelect}/>
                <Main api={api} challenge={selectedChallenge}/>
            </BrowserRouter>
        </Container>
    );
}

export default function App() {
    const prefersDarkMode = useMediaQuery('(prefers-color-scheme: dark)');
    const customTheme = React.useMemo(() => importedTheme(prefersDarkMode ? 'dark' : 'light'), [prefersDarkMode]);
    return (
        <ThemeProvider theme={customTheme}>
            <CssBaseline enableColorScheme/>
            <Root/>
        </ThemeProvider>
    );
}