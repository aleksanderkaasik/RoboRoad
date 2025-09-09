import React, { useState, useEffect } from 'react';

const ListNodes = ({ nodes = [], onNodeSelect, selectedNode }) => {
    return (
        <div className="scrollable-content">
            {nodes.map(node => (
                <div
                    key={node.NodeId}
                    className={`sidebar-item ${selectedNode?.NodeId === node.NodeId ? 'selected' : ''}`}
                    onClick={() => onNodeSelect(node)}
                >
                    {node.NodeName}
                </div>
            ))}
        </div>
    );
};

export default ListNodes;
