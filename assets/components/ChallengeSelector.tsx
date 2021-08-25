import * as React from 'react';
import ListItem from '@material-ui/core/ListItem';
import ListItemIcon from '@material-ui/core/ListItemIcon';
import ListItemText from '@material-ui/core/ListItemText';
import BusinessIcon from '@material-ui/icons/Business';
import ShoppingCartIcon from '@material-ui/icons/ShoppingCart';
import PeopleIcon from '@material-ui/icons/People';
import BarChartIcon from '@material-ui/icons/BarChart';
import LayersIcon from '@material-ui/icons/Layers';
import {Challenge, DefaultApi} from "../gen";
import {useEffect, useState} from "react";

type ChallengerSelectorProps = {
    api: DefaultApi,
    onSelect: (id: number, name: string, count: number) => void
}

const ChallengeSelector = ({api, onSelect}: ChallengerSelectorProps) => {
    const [list, setList] = useState<Array<Challenge>>([]);
    const IconsList = [<BusinessIcon/>, <ShoppingCartIcon/>, <PeopleIcon/>, <BarChartIcon/>, <LayersIcon/>];
    useEffect(() => {
        if (list.length === 0) {
            api.challengeGet().then(items => {
                setList(items);
                onSelect(items[0].id, items[0].name, items[0].count)
            })
        }
        return () => {
        }
    }, []);

    const selectChange = (event: React.MouseEvent<HTMLDivElement, Event>) => {
        const {dataset} = event.currentTarget;
        onSelect(parseInt(dataset.itemId), dataset.itemName, parseInt(dataset.itemCount));
    }

    return (
        <div>
            {list.map((item: Challenge, index: number) =>
                <ListItem button key={item.id} onClick={selectChange} data-item-id={item.id} data-item-name={item.name}
                          data-item-count={item.count}>
                    <ListItemIcon>
                        {IconsList[index]}
                    </ListItemIcon>
                    <ListItemText primary={item.name}/>
                </ListItem>
            )}
        </div>
    );
};

export default ChallengeSelector;