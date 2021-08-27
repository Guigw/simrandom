import Typography from "@material-ui/core/Typography";
import * as React from "react";

const Licence = () => {
    return (
        <Typography variant="body2" color="textSecondary" align="center">
            <img src={'https://www.gnu.org/graphics/lgplv3-88x31.png'} alt={'LGPLv3 Image'}/>
            {new Date().getFullYear()}
            {'.'}
        </Typography>
    );
}

export default Licence