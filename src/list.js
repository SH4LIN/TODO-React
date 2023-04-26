import './list.css'
import {faCheckSquare, faPenToSquare, faTrash} from "@fortawesome/free-solid-svg-icons";
import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
function List ({list, checkTask, deleteTask, editTask}) {
	return (
		<div className="ToDo-list">
		{
			list.map((item, index) => {
				let itemName = "ToDo-item";
				if (item.isDone) {
					itemName += " done";
				}
				return (
					<div className={itemName} key={item.id}>
					{
						item.isDone ?
							<FontAwesomeIcon className="check-button" icon={faCheckSquare} onClick={(e) => {
								e.preventDefault();
								checkTask(item.id)
							}}/> :
							<div className="square" onClick={(e) => {
								e.preventDefault();
								checkTask(item.id)
							}}/>
					}
					<div className="task-name">
						{item.value}
					</div>
					<FontAwesomeIcon className="edit-button" icon={faPenToSquare} onClick={() => {
						editTask(item.id, item.value)
					}}/>
					<FontAwesomeIcon className="delete-button" icon={faTrash} onClick={() => {
						deleteTask(item.id)
					}}/>
				</div>
				)
			})
		}
	  </div>
		 

	);
}

export default List;