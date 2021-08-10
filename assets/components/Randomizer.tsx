import {DefaultApi} from "../gen";
import {useEffect, useImperativeHandle, useState, forwardRef} from "react";
import * as React from "react";

type RandomizerProps = {
    name: string,
    extra?: string,
    api: DefaultApi,
    onResult: (name: string, result: string) => void,
    needRequirement: (from: string, to: string) => string
}

const Randomizer = forwardRef(({name, extra, api, onResult, needRequirement}: RandomizerProps, ref) => {
    useImperativeHandle(ref, () => ({
        resetResult() {
            setResult(null);
            setExtraState(null);
        }
    }))

    interface apiParams {
        name: string,
        number?: string
    }

    const [result, setResult] = useState<string | null>(null);
    const [extraState, setExtraState] = useState<string | null>(extra);
    useEffect(() => {
        let mount = true;
        let params: [string, string?] = [name];
        if (extraState) {
            console.log("i have extra param", extraState)
            params[1] = extraState;
        }
        if (!result) {
            api.randomizerNameGet(...params).then(random => {
                if (random.result == "" && random.required) {
                    const req = needRequirement(name, random.required);
                    if (req != "") {
                        setExtraState(req);
                    }
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
            return (<p>{result}</p>)
        } else {
            return (<p>On charge</p>)
        }
    }

    return (
        <li>
            <h3>{name}</h3>
            {displayResult()}
            <button onClick={() => setResult(null)}>Refresh</button>
        </li>
    )
})

export default Randomizer