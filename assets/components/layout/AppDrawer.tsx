import Drawer from "@material-ui/core/Drawer";
import clsx from "clsx";
import IconButton from "@material-ui/core/IconButton";
import ChevronLeftIcon from "@material-ui/icons/ChevronLeft";
import Divider from "@material-ui/core/Divider";
import List from "@material-ui/core/List";
import ChallengeSelector from "../ChallengeSelector";
import * as React from "react";
import {makeStyles} from "@material-ui/core/styles";
import {Challenge} from "../../gen";
import {useLocation} from "react-router";
import SaveIcon from '@material-ui/icons/Save';
import {ListItem, ListItemIcon} from "@material-ui/core";
import {Fragment} from "react";
import ListItemText from "@material-ui/core/ListItemText";

const drawerWidth = 240;

const useStyles = makeStyles((theme) => ({
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
                <IconButton onClick={handleDrawerClose}>
                    <ChevronLeftIcon/>
                </IconButton>
            </div>
            <Divider/>
            <List><ChallengeSelector list={list} onSelect={onSelect} selectedItem={selectedChallenge}/></List>
            <Divider/>
            {selectedSaved && (
                <Fragment>
                    <ListItem>
                        <ListItemIcon>
                            <SaveIcon/>
                        </ListItemIcon>
                        <ListItemText primary={'Saved'}/>
                    </ListItem>
                    <Divider/>
                </Fragment>
            )}
        </Drawer>
    )
}

export default AppDrawer