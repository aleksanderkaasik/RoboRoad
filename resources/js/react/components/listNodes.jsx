// ListNodes.js
import React, { useState, useEffect, useRef } from 'react';
import DeleteConfirmationModal from './DeleteConfirmation.jsx';
import Edit from './Editing.jsx';

const ListNodes = ({ nodes = [], onNodeSelect, selectedNode, refreshData }) => {
    const [menuOpen, setMenuOpen] = useState(null);
    const [nodeToDelete, setNodeToDelete] = useState(null);
    const [nodeToEdit, setNodeToEdit] = useState(null);

    const modalRef = useRef(null);
    const menuRef = useRef(null);

    const handleOutsideClick = (e) => {
        if (modalRef.current && !modalRef.current.contains(e.target)) {
            setNodeToDelete(null);
            setNodeToEdit(null);
        }
        if (menuRef.current && !menuRef.current.contains(e.target)) {
            setMenuOpen(null);
        }
    };

    useEffect(() => {
        if (nodeToDelete || nodeToEdit || menuOpen !== null) {
            document.addEventListener('mousedown', handleOutsideClick);
        }

        return () => {
            document.removeEventListener('mousedown', handleOutsideClick);
        };
    }, [nodeToDelete, nodeToEdit, menuOpen]);

    const handleMenuToggle = (nodeId) => {
        setMenuOpen(prev => (prev === nodeId ? null : nodeId));
    };

    const handleDeleteClick = (node) => {
        setNodeToDelete(node);
        setMenuOpen(null);
    };

    const handleEditClick = (node) => {
        setNodeToEdit(node);
        setMenuOpen(null);
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

            refreshData();
            setNodeToDelete(null);
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
                                        <button onClick={() => handleEditClick(node)}>Update</button>
                                        <button onClick={() => handleDeleteClick(node)}>Delete</button>
                                    </div>
                                )}
                            </div>
                        </div>
                    );
                })
            )}

            {/* Delete Modal */}
            {nodeToDelete && (
                <div ref={modalRef}>
                    <DeleteConfirmationModal
                        node={nodeToDelete}
                        onConfirm={handleConfirmDelete}
                        onCancel={() => setNodeToDelete(null)}
                    />
                </div>
            )}

            {/* Edit Modal */}
            {nodeToEdit && (
                <div ref={modalRef}>
                    <Edit
                        node={nodeToEdit}
                        onUpdate={refreshData}
                        onCancel={() => setNodeToEdit(null)}
                    />
                </div>
            )}
        </div>
    );
};

export default ListNodes;
