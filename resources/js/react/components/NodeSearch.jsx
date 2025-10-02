import React from 'react';

const NodeSearch  = ({searchQuery, setSearchQuery}) => {
    return (
        <input
            type="text"
            placeholder="Search nodes..."
            value={searchQuery}
            onChange={(e) => setSearchQuery(e.target.value)}
            className="search-input"
        />
    )
}

export default NodeSearch;
