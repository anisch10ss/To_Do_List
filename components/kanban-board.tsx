"use client"

import { useState } from "react"
import { Card } from "@/components/ui/card"
import { Button } from "@/components/ui/button"
import { PlusCircle } from "lucide-react"
import { TaskCard } from "@/components/task-card"

type Task = {
  id: string
  title: string
  description: string
  category: string
  color: string
}

export function KanbanBoard() {
  const [tasks, setTasks] = useState<Task[]>([
    {
      id: "1",
      title: "Social Media",
      description: "Plan social content, Schedule posts, Plan promotion and distribution",
      category: "todo",
      color: "bg-yellow-100",
    },
    {
      id: "2",
      title: "Content Strategy",
      description:
        "What content to get insights, target audience, keywords, etc. Later, I would be good to focus on researching my target users and email newsletter. Also need to brainstorm on landing",
      category: "in-progress",
      color: "bg-blue-100",
    },
    {
      id: "3",
      title: "Email A/B Tests",
      description: "Subject lines, CTA, Sending times",
      category: "done",
      color: "bg-red-100",
    },
    {
      id: "4",
      title: "Banner Ads",
      description:
        "Notes from the workshop, Choose color palette, Choose distinctive imagery, The landing page must match the display ad",
      category: "todo",
      color: "bg-orange-200",
    },
  ])

  const categories = [
    { id: "todo", name: "To Do" },
    { id: "in-progress", name: "In Progress" },
    { id: "done", name: "Done" },
  ]

  const handleMarkComplete = (taskId: string) => {
    setTasks(tasks.map((task) => (task.id === taskId ? { ...task, category: "done" } : task)))
  }

  return (
    <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
      {categories.map((category) => (
        <div key={category.id} className="space-y-4">
          <div className="flex items-center justify-between">
            <h3 className="font-semibold text-lg">{category.name}</h3>
            <span className="text-sm text-muted-foreground">
              {tasks.filter((task) => task.category === category.id).length}
            </span>
          </div>
          <div className="space-y-4">
            {tasks
              .filter((task) => task.category === category.id)
              .map((task) => (
                <TaskCard key={task.id} task={task} onMarkComplete={handleMarkComplete} />
              ))}
            {category.id === "todo" && (
              <Card className="border-dashed border-2 flex items-center justify-center p-4 cursor-pointer hover:bg-muted/50">
                <Button variant="ghost" className="flex items-center gap-1">
                  <PlusCircle className="h-4 w-4" />
                  <span>Add Task</span>
                </Button>
              </Card>
            )}
          </div>
        </div>
      ))}
    </div>
  )
}
