import {DefaultApi} from "../gen";
import {useEffect, useImperativeHandle, useState, forwardRef} from "react";
import * as React from "react";
import "../style/Randomizer.less";
import RandomizerListItem from "./RandomizerListItem";

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

    const toggleCheck = () => {
        setActive(!active);
        onToggle(name, !active);
    }
    return (
        <RandomizerListItem key={name + "-check"} name={name} active={active} result={result} onChange={toggleCheck}
                            onClickRefresh={() => setResult(null)}/>
    )
})

export default Randomizer