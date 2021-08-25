import ListItemIcon from "@material-ui/core/ListItemIcon";
import Switch from "@material-ui/core/Switch";
import ListItemText from "@material-ui/core/ListItemText";
import CircularProgress from "@material-ui/core/CircularProgress";
import ListItem from "@material-ui/core/ListItem";
import * as React from "react";
import ListItemSecondaryAction from "@material-ui/core/ListItemSecondaryAction";
import IconButton from "@material-ui/core/IconButton";
import RefreshIcon from "@material-ui/icons/Refresh";
import {makeStyles} from "@material-ui/core/styles";
import Skeleton from "@material-ui/lab/Skeleton";

type RandomizerListItemProps = {
    name: string,
    active?: boolean,
    onChange?: () => void,
    onClickRefresh?: () => void,
    result?: string,
    skeleton?: boolean
};

const useStyles = makeStyles(() => ({
    randomizerText: {
        minHeight: "40px",
    },
    skeletonContainer: {
        display: "flex",
    },
    skeletonSwitch: {
        padding: "12px",
    }
}));

const RandomizerListItem = ({name, active = true, result, skeleton = false, onChange, onClickRefresh}: RandomizerListItemProps) => {
    const classes = useStyles();
    const labelId = `checkbox-list-label-${name}`;
    return (
        <ListItem role={undefined} dense button divider>
            <ListItemIcon>
                {!skeleton &&
                <Switch
                    checked={active}
                    size="medium"
                    onChange={onChange}
                />}
                {skeleton &&
                <Skeleton variant="rect" width={46} height={26} className={classes.skeletonSwitch}/>}
            </ListItemIcon>
            {!skeleton && <ListItemText className={classes.randomizerText} id={labelId} primary={name}
                                        secondary={(active) ? (result ? result :
                                            <CircularProgress size="12px" color="inherit"/>) : ""}/>}
            {skeleton && <ListItemText primary={<Skeleton/>} secondary={<Skeleton/>}/>}
            {(active && onChange) &&
            <ListItem role={undefined} dense button>
                <ListItemSecondaryAction>
                    {!skeleton &&
                    <IconButton aria-label="refresh" onClick={onClickRefresh}>
                        <RefreshIcon/>
                    </IconButton>}
                    {skeleton &&
                    <IconButton>
                        <Skeleton variant="circle" width={24} height={24}/>
                    </IconButton>}
                </ListItemSecondaryAction>
            </ListItem>}
        </ListItem>
    )
}

export default RandomizerListItem;