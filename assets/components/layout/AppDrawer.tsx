import Drawer from "@mui/material/Drawer";
import clsx from "clsx";
import IconButton from "@mui/material/IconButton";
import ChevronLeftIcon from "@mui/icons-material/ChevronLeft";
import Divider from "@mui/material/Divider";
import List from "@mui/material/List";
import ChallengeSelector from "../ChallengeSelector";
import * as React from "react";
import {makeStyles} from '@mui/styles';
import {Challenge} from "../../gen";
import {useLocation} from "react-router";
import SaveIcon from '@mui/icons-material/Save';
import {ListItem, ListItemIcon} from "@mui/material";
import {Fragment} from "react";
import ListItemText from "@mui/material/ListItemText";

const drawerWidth = 240;

const useStyles = makeStyles((theme: any) => ({
    drawerPaper: {
        position: 'relative',
        whiteSpace: 'nowrap',
        width: drawerWidth,
        transition: theme.transitions.create('width', {
            easing: theme.transitions.easing.sharp,
            duration: theme.transitions.duration.enteringScreen,
        }),
    },
    drawerPaperClose: {
        overflowX: 'hidden',
        transition: theme.transitions.create('width', {
            easing: theme.transitions.easing.sharp,
            duration: theme.transitions.duration.leavingScreen,
        }),
        width: theme.spacing(7),
        [theme.breakpoints.up('sm')]: {
            width: theme.spacing(9),
        },
    },
    toolbarIcon: {
        display: 'flex',
        alignItems: 'center',
        justifyContent: 'flex-end',
        padding: '0 8px',
        ...theme.mixins.toolbar,
    },
    itemSelected: {
        backgroundColor: theme.palette.primary[400],
    }
}))

interface AppDrawerProps {
    open: boolean,
    handleDrawerClose: () => void,
    list: Array<Challenge>,
    onSelect: (id: number, name: string, count: number) => void
}

const AppDrawer = ({open, handleDrawerClose, list, onSelect}: AppDrawerProps) => {
    const classes = useStyles();
    const location = useLocation();
    const selectedChallenge = location.pathname.replace('/randomize/challenge/', '');
    const selectedSaved = location.pathname.match(/\/challenge\/\b[0-9a-f]{8}\b-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-\b[0-9a-f]{12}\b/i) !== null
    return (
        <Drawer
            variant="permanent"
            classes={{
                paper: clsx(classes.drawerPaper, !open && classes.drawerPaperClose),
            }}
            open={open}
        >
            <div className={classes.toolbarIcon}>
                <IconButton onClick={handleDrawerClose} size="large">
                    <ChevronLeftIcon/>
                </IconButton>
            </div>
            <Divider/>
            <List><ChallengeSelector list={list} onSelect={onSelect} selectedItem={selectedChallenge}/></List>
            <Divider/>
            {selectedSaved && (
                <Fragment>
                    <List>
                        <ListItem className={classes.itemSelected}>
                            <ListItemIcon>
                                <SaveIcon/>
                            </ListItemIcon>
                            <ListItemText primary={'Saved'}/>
                        </ListItem>
                    </List>
                    <Divider/>
                </Fragment>
            )}
        </Drawer>
    );
}

export default AppDrawer