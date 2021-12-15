import * as React from 'react';
import {Fragment} from 'react';
import ListItem from '@mui/material/ListItem';
import ListItemIcon from '@mui/material/ListItemIcon';
import ListItemText from '@mui/material/ListItemText';
import HomeWork from '@mui/icons-material/HomeWork';
import HomeWorkOutlined from '@mui/icons-material/HomeWorkOutlined';
import ShoppingCartIcon from '@mui/icons-material/ShoppingCart';
import PeopleIcon from '@mui/icons-material/People';
import BarChartIcon from '@mui/icons-material/BarChart';
import LayersIcon from '@mui/icons-material/Layers';
import {Challenge} from "../gen";
import {Link} from 'react-router-dom';
import {styled, useTheme} from "@mui/material";

const CustomLink = styled(Link)(({theme}) => ({
    textDecoration: "none",
    color: "inherit"
}))

type ChallengerSelectorProps = {
    onSelect: (id: number, name: string, count: number) => void
    list: Array<Challenge>
    selectedItem?: string | null
}

const ChallengeSelector = ({onSelect, list, selectedItem}: ChallengerSelectorProps) => {
    const theme = useTheme();
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
                <CustomLink to={'/randomize/challenge/' + item.name.toLowerCase()} key={item.id}>
                    <ListItem button key={item.id} onClick={selectChange}
                              sx={{
                                  ...((selectedItem && compName(selectedItem, item.name) && {
                                      backgroundColor: theme.palette.primary.light,
                                  }))
                              }}
                              data-item-id={item.id}
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
                </CustomLink>
            )}
        </Fragment>
    );
};

export default ChallengeSelector;