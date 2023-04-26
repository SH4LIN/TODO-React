import {useState} from 'react'
import './App.css';
import List from './list'

function ToDo() {
    const storedItems = JSON.parse(localStorage.getItem('toDoList'));
    const [inputValue, setInputValue] = useState('');
    const [toDoList, setToDoList] = useState(storedItems || []);
    const [isUpdate, setIsUpdate] = useState(false);
    const [updateId, setUpdateId] = useState(0);

    const addTask = () => {
        if(isUpdate) {
            setToDoList( list => {
                const newList = list.map(item => {
                    if (item.id === updateId) {
                        item.value = inputValue;
                    }
                    return item;
                })
                localStorage.setItem('toDoList', JSON.stringify(newList));
                setIsUpdate(false);
                setUpdateId(0);
                setInputValue('');
                return newList;
            })
        } else {
            setToDoList(list => {
                    if (inputValue === '') {
                        return list;
                    }
                    const nextId = list.length + 1;
                    const newList = [
                        ...list,
                        {id: nextId, value: inputValue, isDone: false}
                    ]
                    localStorage.setItem('toDoList', JSON.stringify(newList));
                    setInputValue('');
                    return newList;
                }
            )
        }
    }

    const checkTask = (id) => {
        setToDoList( list => {
            const newList = list.map(item => {
                if (item.id === id) {
                    item.isDone = !item.isDone;
                }
                console.log(item);
                return item;
            })

            localStorage.setItem('toDoList', JSON.stringify(newList));
            return newList;
        })
    }

    const deleteTask = (id) => {
        setToDoList( list => {
            const newList = list.filter(item => item.id !== id);
            localStorage.setItem('toDoList', JSON.stringify(newList));
            return newList;
        })
    }

    const editTask = (id, value) => {
        setInputValue(value);
        setUpdateId(id);
        setIsUpdate(true);
    }

    const inputChange = (e) => {
        setInputValue(e.target.value);
    }

    return (
        <div className="ToDo">
            <h1 className="ToDo-heading">TODO LIST</h1>
            <input type="text" value={inputValue} className="ToDo-input" onChange={inputChange}/>
            <button className="ToDo-add" onClick={addTask}>{ isUpdate ? "UPDATE" : "ADD" }</button>
            <List list={toDoList} checkTask={checkTask} deleteTask={deleteTask} editTask={editTask} />
        </div>
    );
}

export default ToDo;
