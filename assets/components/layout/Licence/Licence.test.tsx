import * as React from "react";
import Licence from "./Licence";
import {render, screen} from '@testing-library/react';
import '@testing-library/jest-dom';

test('Licence exists', () => {
    render(<Licence/>);
    const linkElement = screen.getByText(new Date().getFullYear() + ".");
    expect(linkElement).toBeInTheDocument();
});