import * as React from "react";
import {render, screen} from '@testing-library/react';
import '@testing-library/jest-dom';
import Licence from "./Licence";

test('Licence exists', () => {
    render(<Licence/>);
    const linkElement = screen.getByText(new Date().getFullYear() + ".");
    expect(linkElement).toBeInTheDocument();
});