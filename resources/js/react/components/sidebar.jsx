import React, { useState, useEffect } from 'react';

import ListNodes from './listNodes.jsx';
import Logo from './logo.jsx';

const Sidebar = ({ data, onNodeSelect, selectedNode }) => {
    return (
        <div className="Sidebar">
            <Logo />
            <ListNodes
                nodes={data}
                onNodeSelect={onNodeSelect}
                selectedNode={selectedNode}
            />
        </div>
    );
};


export default Sidebar;
