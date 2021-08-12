import {DefaultApi} from "../gen";
import {useEffect, useImperativeHandle, useState, forwardRef, Fragment} from "react";
import * as React from "react";
import "../style/Randomizer.less";
import RefreshIcon from '@material-ui/icons/Refresh';
import ListItem from '@material-ui/core/ListItem';
import ListItemIcon from '@material-ui/core/ListItemIcon';
import ListItemSecondaryAction from '@material-ui/core/ListItemSecondaryAction';
import ListItemText from '@material-ui/core/ListItemText';
import Checkbox from '@material-ui/core/Checkbox';
import IconButton from '@material-ui/core/IconButton';
import CommentIcon from '@material-ui/icons/Comment';

type RandomizerProps = {
    name: string,
    activeProps?: boolean,
    api: DefaultApi,
    onResult: (name: string, result: string) => void,
    onToggle: (name: string, active: boolean) => void,
    needRequirement: (from: string, to: string) => string
}

const Randomizer = forwardRef(({name, activeProps, api, onResult, onToggle, needRequirement}: RandomizerProps, ref) => {
    useImperativeHandle(ref, () => ({
        resetResult() {
            setResult(null);
            setExtraState(null);
        }
    }))

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

    const displayResult = () => {
        if (result) {
            return (<ListItemText className={"result"}>{result}</ListItemText>)
        } else {
            return (<ListItemText className={"result"}>On charge</ListItemText>)
        }
    }

    const toggleCheck = () => {
        setActive(!active);
        onToggle(name, !active);
    }

    const optionalRendering = () => {
        if (active) {
            return (
                <div>
                    {displayResult()}
                    <ListItemSecondaryAction>
                        <IconButton aria-label="refresh" onClick={() => setResult(null)}>
                            <RefreshIcon/>
                        </IconButton>
                    </ListItemSecondaryAction>
                </div>
            )
        }
    }

    const labelId = `checkbox-list-label-${name}`;
    return (
        <ListItem key={name} role={undefined} dense button>
            <ListItemIcon>
                <Checkbox
                    edge="start"
                    checked={active}
                    tabIndex={-1}
                    disableRipple
                    inputProps={{'aria-labelledby': labelId}}
                    onChange={toggleCheck}
                />
            </ListItemIcon>
            <ListItemText id={labelId} primary={name} />
            {optionalRendering()}
        </ListItem>
    )
})

export default Randomizer