import React, { useState, useEffect } from 'react';

const ListNodes = ({ nodes = [], onNodeSelect, selectedNode }) => {
    return (
        <div className="scrollable-content">
            {nodes.length === 0 ? (
                <div className="no-results" style={{ padding: '1em', color: '#888' }}>
                    No results found.
                </div>
            ) : (
                nodes.map(node => {
                    const isSelected = selectedNode?.NodeId === node.NodeId;
                    return (
                        <div
                            key={node.NodeId}
                            className={`sidebar-item ${isSelected ? 'selected' : ''}`}
                            onClick={() => onNodeSelect(node)}
                        >
                            {node.NodeName}
                        </div>
                    );
                })
            )}
        </div>
    );
};

export default ListNodes;
