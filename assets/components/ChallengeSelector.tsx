import * as React from 'react';
import {Fragment, useEffect, useState} from 'react';
import {Challenge, DefaultApi, createConfiguration} from '../gen';

const ChallengeSelector = () => {
    const [list, setList] = useState<Array<Challenge> | null>(null);
    useEffect(() => {
        if (!list) {
            let conf = createConfiguration()
            let api = new DefaultApi(conf);
            console.log('api.challengeGet()');
            api.challengeGet().then(items => {
                setList(items);
            })
        }
        return () => {
        }
    });
    if (list) {
        return (
            <Fragment>
                <select>
                    {list.map(item => <option value={item.id}>{item.name}</option>)}
                </select>
                <button onClick={() => setList(null)}>Refresh</button>
            </Fragment>

        );
    } else {
        return <div>Loading</div>;
    }

}

export default ChallengeSelector;