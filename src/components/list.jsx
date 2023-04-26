/**
 * This file is used to create the TODO List for the Task list and Completed list.
 */

import './list.css'
import {faPenToSquare, faTrash} from "@fortawesome/free-solid-svg-icons";
import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";

/**
 * This function is used to create the TODO List for the Task list and Completed list.
 *
 * @param listName
 * @param list
 * @param checkTask
 * @param deleteTask
 * @param editTask
 * @param clearAll
 * @returns {JSX.Element|null}
 * @constructor
 */
function List ({listName, list, checkTask, deleteTask, editTask, clearAll=null}) {
	// Returning if list is empty.
	if(list.length === 0) {
		return null;
	}
	return (
		<div className="ToDo-list-container">
			<h1 className="ToDo-heading">{listName}</h1>
			<div className="ToDo-list">
				{clearAll !== null ? <div className="ToDo-clear-all-container">
					{clearAll}
				</div> : null}

				{
					list.map((item, index) => {
						let itemClass = "ToDo-item";
						// Adding done class if task is completed.
						if (item.done) {
							itemClass += " done";
						}
						const edit = <FontAwesomeIcon className="edit-button" icon={faPenToSquare} onClick={() => {
							editTask(item.id, item.value)
						}}/>
						const deleteItem = <FontAwesomeIcon className="delete-button" icon={faTrash} onClick={() => {
							deleteTask(item.id)
						}}/>
						return (
							<div className={itemClass} key={item.id}>

								<input type="checkbox" checked={item.done} onChange={()=> {
									checkTask(item.id)
								}}/>

								<div className="task-name">
									{item.value}
								</div>
								{
									// Displaying edit button only if task is not completed.
									item.done ?  null : edit
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