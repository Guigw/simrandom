import {DefaultApi, RandomizerResult} from "../../gen";
import * as React from "react";
import {forwardRef, useEffect, useImperativeHandle, useState} from "react";
import RandomizerListItem from "../RandomizerListItem/RandomizerListItem";

type RandomizerProps = {
    name: string,
    activeProps?: boolean,
    api: DefaultApi,
    onResult: (result: RandomizerResult) => void,
    onToggle: (name: string, active: boolean) => void,
    needRequirement: (from: string, to: string) => string
}

const Randomizer = forwardRef(({name, activeProps, api, onResult, onToggle, needRequirement}: RandomizerProps, ref) => {
    useImperativeHandle(ref, () => ({
        resetResult() {
            setResult(null);
            setExtraState(null);
        },
        getResult() {
            return result;
        }
    }))
    const [result, setResult] = useState<RandomizerResult | null>(null);
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
                    setExtraState(needRequirement(name, random.required));
                } else {
                    if (mount) {
                        setResult(random);
                        onResult(random);
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
        <RandomizerListItem key={name + "-check"} name={name} active={active} result={result ? result.result : null}
                            onChange={toggleCheck}
                            onClickRefresh={() => setResult(null)}/>
    )
})

export default Randomizer