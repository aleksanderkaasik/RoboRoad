import React, { useState, useEffect, useRef } from 'react';

const ListNodes = ({ nodes = [], onNodeSelect, selectedNode }) => {

    const [menuOpen, setMenuOpen] = useState(null);
    const [showModal, setShowModal] = useState(false);

    const modalRef = useRef(null);
    const menuRef = useRef(null);

    const handleOutsideClick = (e) => {
        if (modalRef.current && !modalRef.current.contains(e.target)) {
            setShowModal(false); // Close modal if clicked outside
        }
        if (menuRef.current && !menuRef.current.contains(e.target)) {
            setMenuOpen(null); // Close menu if clicked outside
        }
    };

    useEffect(() => {
        if (showModal || menuOpen !== null) {
            document.addEventListener('mousedown', handleOutsideClick);
        }

        return () => {
            document.removeEventListener('mousedown', handleOutsideClick);
        };
    }, [showModal, menuOpen]);

    const handleMenuToggle = (nodeId) => {
        setMenuOpen(prev => (prev === nodeId ? null : nodeId)); // Toggle the menu
    };

    return (
        <div className="scrollable-content">
            {nodes.length === 0 ? (
                <div className="no-results" style={{ padding: '1em', color: '#888' }}>
                    No results found.
                </div>
            ) : (
                nodes.map((node) => {
                    const isSelected = selectedNode?.NodeId === node.NodeId;

                    return (
                        <div
                            key={node.NodeId}
                            className={`sidebar-item ${isSelected ? 'selected' : ''}`}
                            onClick={() => onNodeSelect(node)}
                        >
                            {node.NodeName}
                            <div className="dropdown" ref={menuRef}>
                                <button
                                    className="dropdown-btn"
                                    onClick={(e) => {
                                        e.stopPropagation();
                                        handleMenuToggle(node.NodeId);
                                    }}
                                >
                                    &#8230;
                                </button>
                                {menuOpen === node.NodeId && (
                                    <div className="dropdown-menu">
                                        <button>Update</button>
                                        <button>Delete</button>
                                    </div>
                                )}
                            </div>
                        </div>
                    );
                })
            )}
        </div>
    );
};

export default ListNodes;
