import * as React from "react";
import {render, screen} from '@testing-library/react';
import '@testing-library/jest-dom';
import Title from "./Title";

test("title exists", () => {
    render(<Title>
        <div>coucou</div>
    </Title>);
    const linkElement = screen.getByText("coucou");
    expect(linkElement).toBeInTheDocument();
});