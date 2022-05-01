import MuiDrawer from '@mui/material/Drawer';
import IconButton from "@mui/material/IconButton";
import ChevronLeftIcon from "@mui/icons-material/ChevronLeft";
import Divider from "@mui/material/Divider";
import List from "@mui/material/List";
import ChallengeSelector from "../../ChallengeSelector/ChallengeSelector";
import * as React from "react";
import {Fragment} from "react";
import {Challenge} from "../../../gen";
import {useLocation} from "react-router";
import SaveIcon from '@mui/icons-material/Save';
import {ListItem, ListItemIcon, styled} from "@mui/material";
import ListItemText from "@mui/material/ListItemText";
import Toolbar from "@mui/material/Toolbar";

const drawerWidth: number = 240;

interface AppDrawerProps {
    open: boolean,
    handleDrawerClose: () => void,
    list: Array<Challenge>,
    onSelect: (id: number, name: string, count: number) => void
}

const Drawer = styled(MuiDrawer, {shouldForwardProp: (prop) => prop !== 'open'})(
    ({theme, open}) => ({
        '& .MuiDrawer-paper': {
            position: 'relative',
            whiteSpace: 'nowrap',
            width: drawerWidth,
            transition: theme.transitions.create('width', {
                easing: theme.transitions.easing.sharp,
                duration: theme.transitions.duration.enteringScreen,
            }),
            boxSizing: 'border-box',
            ...(!open && {
                overflowX: 'hidden',
                transition: theme.transitions.create('width', {
                    easing: theme.transitions.easing.sharp,
                    duration: theme.transitions.duration.leavingScreen,
                }),
                width: theme.spacing(7),
                [theme.breakpoints.up('sm')]: {
                    width: theme.spacing(9),
                },
            }),
        },
    }),
);

const ListItemThemed = styled(ListItem)(({theme}) => ({
    backgroundColor: theme.palette.primary.light,
}))

const AppDrawer = ({open, handleDrawerClose, list, onSelect}: AppDrawerProps) => {
    const location = useLocation();
    const selectedChallenge = location.pathname.replace('/randomize/challenge/', '');
    const selectedSaved = location.pathname.match(/\/challenge\/\b[0-9a-f]{8}\b-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-\b[0-9a-f]{12}\b/i) !== null
    return (
        <Drawer
            variant="permanent"
            open={open}
        >
            <Toolbar
                sx={{
                    display: 'flex',
                    alignItems: 'center',
                    justifyContent: 'flex-end',
                    px: [1],
                }}
            >
                <IconButton onClick={handleDrawerClose} size="large">
                    <ChevronLeftIcon/>
                </IconButton>
            </Toolbar>
            <Divider/>
            <List><ChallengeSelector list={list} onSelect={onSelect} selectedItem={selectedChallenge}/></List>
            <Divider/>
            {selectedSaved && (
                <Fragment>
                    <List>
                        <ListItemThemed>
                            <ListItemIcon>
                                <SaveIcon/>
                            </ListItemIcon>
                            <ListItemText primary={'Saved'}/>
                        </ListItemThemed>
                    </List>
                    <Divider/>
                </Fragment>
            )}
        </Drawer>
    );
}

export default AppDrawer