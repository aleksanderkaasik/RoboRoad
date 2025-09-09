import React from "react";

import ListNodes from './listNodes.jsx';
import Logo from './logo.jsx';

const Sidebar = () => {
    return (
        <div className="Sidebar">
            <Logo />
            <ListNodes />
        </div>
    );
};

export default Sidebar;
