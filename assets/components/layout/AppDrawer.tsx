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
import {RouteComponentProps} from "@reach/router";

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

interface AppDrawerProps extends RouteComponentProps {
    open: boolean,
    handleDrawerClose: () => void,
    list: Array<Challenge>,
    onSelect: (id: number, name: string, count: number) => void
}

const AppDrawer = ({open, handleDrawerClose, list, onSelect}: AppDrawerProps) => {
    const classes = useStyles();
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
            <List><ChallengeSelector list={list} onSelect={onSelect}/></List>
            <Divider/>
        </Drawer>
    )
}

export default AppDrawer