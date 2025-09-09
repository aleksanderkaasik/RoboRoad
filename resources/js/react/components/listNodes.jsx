import React from "react";

const ListNodes = () => {
    return (
        <div className="scrollable-content">
            {Array.from({ length: 100 }).map((_, idx) => (
                <div key={idx} className="sidebar-item">Item {idx + 1}</div>
            ))}
        </div>
    );
};

export default ListNodes;
