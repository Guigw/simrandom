import {DefaultApi} from "../gen";
import {useEffect, useImperativeHandle, useState, forwardRef, Fragment} from "react";
import * as React from "react";
import "../style/Randomizer.less";
import RefreshIcon from '@material-ui/icons/Refresh';
import ListItem from '@material-ui/core/ListItem';
import ListItemIcon from '@material-ui/core/ListItemIcon';
import ListItemSecondaryAction from '@material-ui/core/ListItemSecondaryAction';
import ListItemText from '@material-ui/core/ListItemText';
import Switch from "@material-ui/core/Switch";
import CircularProgress from '@material-ui/core/CircularProgress';
import IconButton from '@material-ui/core/IconButton';
import {makeStyles} from "@material-ui/core/styles";

type RandomizerProps = {
    name: string,
    activeProps?: boolean,
    api: DefaultApi,
    onResult: (name: string, result: string) => void,
    onToggle: (name: string, active: boolean) => void,
    needRequirement: (from: string, to: string) => string
}

const useStyles = makeStyles((theme) => ({
    randoText: {
        minHeight: "40px",
    },
}));

const Randomizer = forwardRef(({name, activeProps, api, onResult, onToggle, needRequirement}: RandomizerProps, ref) => {
    useImperativeHandle(ref, () => ({
        resetResult() {
            setResult(null);
            setExtraState(null);
        }
    }))
    const classes = useStyles();
    const [result, setResult] = useState<string | null>(null);
    const [extraState, setExtraState] = useState<string | null>(null);
    const [active, setActive] = useState<boolean>(activeProps || true)
    useEffect(() => {
        let mount = true;
        let params: [string, string?] = [name];
        if (extraState) {
            params[1] = extraState;
        }
        if (!result && active) {
            api.randomizerNameGet(...params).then(random => {
                if (random.result == "" && random.required) {
                    const req = needRequirement(name, random.required);
                    setExtraState(req);
                } else {
                    if (mount) {
                        setResult(random.result);
                        onResult(name, random.result);
                    }
                }
            });
        }
        return () => {
            mount = false
        }
    });

    const toggleCheck = () => {
        setActive(!active);
        onToggle(name, !active);
    }

    const optionalRendering = (name: string) => {
        if (active) {
            return (
                <ListItem  key={name + "-result"} role={undefined} dense button>
                    <ListItemSecondaryAction>
                        <IconButton aria-label="refresh" onClick={() => setResult(null)}>
                            <RefreshIcon/>
                        </IconButton>
                    </ListItemSecondaryAction>
                </ListItem>
            )
        }
    }

    const labelId = `checkbox-list-label-${name}`;
    return (
            <ListItem key={name + "-check"} role={undefined} dense button divider>
                <ListItemIcon>
                <Switch
                    checked={active}
                    size="medium"
                    onChange={toggleCheck}
                />
                </ListItemIcon>
                <ListItemText className={classes.randoText} id={labelId} primary={name} secondary={(active) ? (result ? result : <CircularProgress size="12px" color="inherit" />) : ""}/>
            {optionalRendering(name)}    
            </ListItem>
    )
})

export default Randomizer