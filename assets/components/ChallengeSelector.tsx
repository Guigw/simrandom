import * as React from 'react';
import ListItem from '@material-ui/core/ListItem';
import ListItemIcon from '@material-ui/core/ListItemIcon';
import ListItemText from '@material-ui/core/ListItemText';
import HomeWork from '@material-ui/icons/HomeWork';
import HomeWorkOutlined from '@material-ui/icons/HomeWorkOutlined';
import ShoppingCartIcon from '@material-ui/icons/ShoppingCart';
import PeopleIcon from '@material-ui/icons/People';
import BarChartIcon from '@material-ui/icons/BarChart';
import LayersIcon from '@material-ui/icons/Layers';
import {Challenge} from "../gen";
import {Fragment} from "react";
import {Link} from 'react-router-dom';
import {makeStyles} from "@material-ui/core/styles";

const useStyles = makeStyles(() => ({
    link: {
        textDecoration: "none",
        color: "inherit",
    }
}))

type ChallengerSelectorProps = {
    onSelect: (id: number, name: string, count: number) => void
    list: Array<Challenge>
    selectedItem?: string | null
}

const ChallengeSelector = ({onSelect, list, selectedItem}: ChallengerSelectorProps) => {
    const classes = useStyles();
    const IconsListSelected = [<HomeWork/>, <ShoppingCartIcon/>, <PeopleIcon/>, <BarChartIcon/>, <LayersIcon/>];
    const IconsList = [<HomeWorkOutlined/>, <ShoppingCartIcon/>, <PeopleIcon/>, <BarChartIcon/>, <LayersIcon/>];

    const selectChange = (event: React.MouseEvent<HTMLDivElement, Event>) => {
        const {dataset} = event.currentTarget;
        onSelect(parseInt(dataset.itemId), dataset.itemName, parseInt(dataset.itemCount));
    }

    const compName = (a: string, b: string): boolean => {
        return a.toLowerCase() == b.toLowerCase();
    }

    return (
        <Fragment>
            {list.map((item: Challenge, index: number) =>
                <Link to={'/randomize/challenge/' + item.name.toLowerCase()} className={classes.link}>
                    <ListItem button key={item.id} onClick={selectChange} data-item-id={item.id}
                              data-item-name={item.name}
                              data-item-count={item.count}>
                        <ListItemIcon>
                            {(selectedItem && compName(selectedItem, item.name)) && React.cloneElement(
                                IconsListSelected[index],
                                {color: "action"}
                            )}
                            {(!selectedItem || !compName(selectedItem, item.name)) && React.cloneElement(
                                IconsList[index],
                                {color: "action"}
                            )}
                        </ListItemIcon>
                        <ListItemText primary={item.name}/>
                    </ListItem>
                </Link>
            )}
        </Fragment>
    );
};

export default ChallengeSelector;