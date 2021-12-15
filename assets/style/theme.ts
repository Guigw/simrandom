import {PaletteMode} from "@mui/material";
import {green, grey, lightGreen} from "@mui/material/colors";
import {createTheme} from "@mui/material/styles";

const getDesignTokens = (mode: PaletteMode) => ({
    palette: {
        mode,
        ...(mode === 'light'
            ? {
                // palette values for light mode
                primary: green,
                divider: green[200],
                text: {
                    primary: grey[900],
                    secondary: grey[800],
                },
            }
            : {
                // palette values for dark mode
                primary: lightGreen,
                divider: lightGreen[200],
            }),
    },
});

// A custom theme for this app
const theme = (mode: PaletteMode) => createTheme(getDesignTokens(mode))
export default theme;