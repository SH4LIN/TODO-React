import './list.css'
import {faCheck, faPenToSquare, faTrash} from "@fortawesome/free-solid-svg-icons";
import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";

/**
 * This function is used to create the TODO List for the Task list and Completed list.
 *
 * @param listName
 * @param list
 * @param checkTask
 * @param deleteTask
 * @param editTask
 * @returns {JSX.Element|null}
 * @constructor
 */
function List ({listName, list, checkTask, deleteTask, editTask}) {
	// Returning if list is empty.
	if(list.length === 0) {
		return null;
	}
	return (
		<div className="ToDo-list-container">
			<h1 className="ToDo-heading">{listName}</h1>
			<div className="ToDo-list">
				{
					list.map((item, index) => {
						let itemClass = "ToDo-item";
						// Adding done class if task is completed.
						if (item.done) {
							itemClass += " done";
						}
						const check = <FontAwesomeIcon className="check-button" icon={faCheck} onClick={(e) => {
							checkTask(item.id)
						}}/>
						const edit = <FontAwesomeIcon className="edit-button" icon={faPenToSquare} onClick={() => {
							editTask(item.id, item.value)
						}}/>
						const deleteItem = <FontAwesomeIcon className="delete-button" icon={faTrash} onClick={() => {
							deleteTask(item.id)
						}}/>
						return (
							<div className={itemClass} key={item.id}>
								{
									// Displaying check button only if task is not completed.
									item.done ?  null : check
								}
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