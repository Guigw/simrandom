import {DefaultApi} from "../gen";
import {useEffect, useState} from "react";
import * as React from "react";

type RandomizerProps = {
    name: string,
    api: DefaultApi
}

const Randomizer = ({name, api}: RandomizerProps) => {
    const [result, setResult] = useState<string | null>(null);
    useEffect(() => {
        if (!result) {
            api.randomizerNameGet(name).then(random => {
                setResult(random.result)
            })
        }
        return () => {
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
}

export default Randomizer