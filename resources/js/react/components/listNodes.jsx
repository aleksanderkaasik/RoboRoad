// ListNodes.js
import React, { useState, useEffect, useRef } from 'react';
import DeleteConfirmationModal from './DeleteConfirmation.jsx';

const ListNodes = ({ nodes = [], onNodeSelect, selectedNode, refreshData }) => {
    const [menuOpen, setMenuOpen] = useState(null);
    const [nodeToDelete, setNodeToDelete] = useState(null);

    const modalRef = useRef(null);
    const menuRef = useRef(null);

    const handleOutsideClick = (e) => {
        if (modalRef.current && !modalRef.current.contains(e.target)) {
            setNodeToDelete(null); // Close modal if clicked outside
        }
        if (menuRef.current && !menuRef.current.contains(e.target)) {
            setMenuOpen(null); // Close menu if clicked outside
        }
    };

    useEffect(() => {
        if (nodeToDelete || menuOpen !== null) {
            document.addEventListener('mousedown', handleOutsideClick);
        }

        return () => {
            document.removeEventListener('mousedown', handleOutsideClick);
        };
    }, [nodeToDelete, menuOpen]);

    const handleMenuToggle = (nodeId) => {
        setMenuOpen(prev => (prev === nodeId ? null : nodeId));
    };

    const handleDeleteClick = (node) => {
        setNodeToDelete(node);
        setMenuOpen(null); // Close the dropdown
    };

    const handleConfirmDelete = async (nodeId) => {
        try {
            const response = await fetch(`http://roboroad.loc/api/nodes/${nodeId}`, {
                method: 'DELETE',
            });
            const data = await response.json();

            if (!data.success) {
                throw new Error('Failed to delete node');
            }

            refreshData(); // Call parent refresh
            setNodeToDelete(null); // Close modal
        } catch (error) {
            console.error('Error deleting node:', error);
        }
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
                                        <button onClick={() => console.log('Update')}>Update</button>
                                        <button onClick={(e) => {
                                            e.stopPropagation();
                                            handleDeleteClick(node);
                                        }}>Delete</button>
                                    </div>
                                )}
                            </div>
                        </div>
                    );
                })
            )}

            {nodeToDelete && (
                <div ref={modalRef}>
                    <DeleteConfirmationModal
                        node={nodeToDelete}
                        onConfirm={handleConfirmDelete}
                        onCancel={() => setNodeToDelete(null)}
                    />
                </div>
            )}
        </div>
    );
};

export default ListNodes;
