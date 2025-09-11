import React, { useState, useEffect } from 'react';

import ListNodes from './listNodes.jsx';
import Logo from './logo.jsx';
import NodeSearch from './NodeSearch.jsx';

const Sidebar = ({ data, onNodeSelect, selectedNode }) => {

    const [searchQuery, setSearchQuery] = useState('');

    const filteredNodes = data.filter(node =>
        node.NodeName.toLowerCase().includes(searchQuery.toLowerCase()) ||
        node.NodeAddress.toLowerCase().includes(searchQuery.toLowerCase())
    );

    return (
        <div className="Sidebar">
            <Logo />

            <NodeSearch
                searchQuery={searchQuery}
                setSearchQuery={setSearchQuery}
            />

            <ListNodes
                nodes={filteredNodes}
                onNodeSelect={onNodeSelect}
                selectedNode={selectedNode}
            />
        </div>
    );
};


export default Sidebar;
