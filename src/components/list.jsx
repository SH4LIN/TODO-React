/**
 * This file is used to create the TODO List for the Task list and Completed list.
 */

import './list.css'
import {faFloppyDisk, faPenToSquare, faTrash} from "@fortawesome/free-solid-svg-icons";
import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import UserInput from "./user-input";
import {useRef} from "react";

/**
 * This function is used to create the TODO List for the Task list and Completed list.
 *
 * @param noResultMessage
 * @param listName
 * @param list
 * @param checkTask
 * @param deleteTask
 * @param editTask
 * @param clearAll
 * @param updateId
 * @param updateTask
 * @param isUpdate
 * @returns {JSX.Element|null}
 * @constructor
 */
function List ({
				   noResultMessage,
				   listName,
				   list,
				   checkTask,
				   deleteTask,
				   editTask,
				   clearAll=null,
				   updateId=null,
				   updateTask,
				   isUpdate=false
}) {
	const updateInputRef = useRef(null);
	// Returning if list is empty.
	return (
		<div className="list-wrapper">
			<h1 className="ToDo-heading">{listName}</h1>
			{
				list.length > 0 ?
					clearAll !== null ?
						<div className="ToDo-clear-all-container">
							{clearAll}
						</div> :
						null:
					<div>
						<strong>
							{noResultMessage}
						</strong>
					</div>
			}
			<div className="ToDo-list">
				{
					list.map((item, index) => {
						let itemClass = "ToDo-item";
						// Adding done class if task is completed.
						if (item.done) {
							itemClass += " done";
						}
						const edit = <FontAwesomeIcon className="edit-button" icon={faPenToSquare} onClick={(e) => {
							e.stopPropagation()
							editTask(item.id, item.value)
						}}/>
						const update = <FontAwesomeIcon className="edit-button" icon={faFloppyDisk} onClick={(e) => {
							e.stopPropagation()
							const value = updateInputRef.current.value
							updateTask(item.id, value)
						}}/>
						const deleteItem = <FontAwesomeIcon className="delete-button" icon={faTrash} onClick={(e) => {
							e.stopPropagation()
							deleteTask(item.id)
						}}/>
						return (
							<div className={itemClass} key={item.id} onClick={() => {
								checkTask(item.id)
								}}>

								<input type="checkbox" checked={item.done} onChange={()=> {
									checkTask(item.id)
								}}/>

								<div className="task-name">
									{updateId === item.id?isUpdate?<UserInput
										isSearch={false}
										showButton={false}
										value={item.value}
										inputRef={updateInputRef}
									/>:item.value:item.value}
								</div>
								{
									// Displaying edit button only if task is not completed.
									item.done ?  null : updateId === item.id?
										isUpdate?
											update:
											edit:
										edit
								}
								{
									// Displaying delete button only if task is not completed.
									item.done ?  null : deleteItem
								}
							</div>
						)
					})
				}
			</div>
		</div>


	);
}

export default List;