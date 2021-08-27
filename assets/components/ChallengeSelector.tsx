import * as React from 'react';
import ListItem from '@material-ui/core/ListItem';
import ListItemIcon from '@material-ui/core/ListItemIcon';
import ListItemText from '@material-ui/core/ListItemText';
import BusinessIcon from '@material-ui/icons/Business';
import ShoppingCartIcon from '@material-ui/icons/ShoppingCart';
import PeopleIcon from '@material-ui/icons/People';
import BarChartIcon from '@material-ui/icons/BarChart';
import LayersIcon from '@material-ui/icons/Layers';
import {Challenge} from "../gen";

type ChallengerSelectorProps = {
    onSelect: (id: number, name: string, count: number) => void
    list: Array<Challenge>
}

const ChallengeSelector = ({onSelect, list}: ChallengerSelectorProps) => {
    const IconsList = [<BusinessIcon/>, <ShoppingCartIcon/>, <PeopleIcon/>, <BarChartIcon/>, <LayersIcon/>];

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