import ListItemIcon from "@mui/material/ListItemIcon";
import Switch from "@mui/material/Switch";
import ListItemText from "@mui/material/ListItemText";
import CircularProgress from "@mui/material/CircularProgress";
import ListItem from "@mui/material/ListItem";
import * as React from "react";
import ListItemSecondaryAction from "@mui/material/ListItemSecondaryAction";
import IconButton from "@mui/material/IconButton";
import RefreshIcon from "@mui/icons-material/Refresh";
import Skeleton from "@mui/material/Skeleton";

type RandomizerListItemProps = {
    name: string,
    active?: boolean,
    onChange?: () => void,
    onClickRefresh?: () => void,
    result?: string,
    skeleton?: boolean
};

const RandomizerListItem = ({name, active = true, result, skeleton = false, onChange, onClickRefresh}: RandomizerListItemProps) => {
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
                    <Skeleton variant="rectangular" width={46} height={26} sx={{display: "flex"}}/>}
            </ListItemIcon>
            {!skeleton && <ListItemText sx={{minHeight: "40px"}} id={labelId} primary={name}
                                        secondary={(active) ? (result ? result :
                                            <CircularProgress size="12px" color="inherit"/>) : ""}/>}
            {skeleton && <ListItemText primary={<Skeleton/>} secondary={<Skeleton/>}/>}
            {(active && onChange) &&
            <ListItem role={undefined} dense button>
                <ListItemSecondaryAction>
                    {!skeleton &&
                    <IconButton aria-label="refresh" onClick={onClickRefresh} size="large">
                        <RefreshIcon/>
                    </IconButton>}
                    {skeleton &&
                    <IconButton size="large">
                        <Skeleton variant="circular" width={24} height={24}/>
                    </IconButton>}
                </ListItemSecondaryAction>
            </ListItem>}
        </ListItem>
    );
}

export default RandomizerListItem;