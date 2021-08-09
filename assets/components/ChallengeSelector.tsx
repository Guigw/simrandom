import * as React from 'react';
import {Fragment, useEffect, useState} from 'react';
import {Challenge, DefaultApi} from '../gen';

type ChallengerSelectorProps = {
    api: DefaultApi,
    onSelect: (challenge: string) => void
}

const ChallengeSelector = ({api, onSelect}: ChallengerSelectorProps) => {
    const [list, setList] = useState<Array<Challenge> | null>(null);
    useEffect(() => {
        if (!list) {
            api.challengeGet().then(items => {
                setList(items);
                onSelect(items[0].id.toString())
            })
        }
        return () => {
        }
    });

    const selectChange = (event: React.ChangeEvent<HTMLSelectElement>) => {
        const value = event.target.value;
        onSelect(value);
    }

    if (list) {
        return (
            <Fragment>
                <select onChange={selectChange}>
                    {list.map(item => <option key={item.id} value={item.id}>{item.name}</option>)}
                </select>
                <button onClick={() => setList(null)}>Refresh</button>
            </Fragment>

        );
    } else {
        return <div>Loading</div>;
    }

}

export default ChallengeSelector;