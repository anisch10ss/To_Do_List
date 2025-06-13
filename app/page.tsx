import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs"
import { KanbanBoard } from "@/components/kanban-board"
import { TaskList } from "@/components/task-list"
import { CreateTaskButton } from "@/components/create-task-button"
import { UserNav } from "@/components/user-nav"
import { Search } from "@/components/search"

export default function Home() {
  return (
    <div className="flex min-h-screen w-full flex-col">
      <header className="sticky top-0 z-10 flex h-16 items-center gap-4 border-b bg-background px-4 md:px-6">
        <div className="flex items-center gap-2 font-semibold">
          <span className="text-xl">TodoList</span>
        </div>
        <div className="ml-auto flex items-center gap-4">
          <Search />
          <UserNav />
        </div>
      </header>
      <main className="flex flex-1 flex-col gap-4 p-4 md:gap-8 md:p-8">
        <div className="flex items-center justify-between">
          <h1 className="text-2xl font-bold">Tasks</h1>
          <CreateTaskButton />
        </div>
        <Tabs defaultValue="kanban">
          <div className="flex items-center justify-between">
            <TabsList>
              <TabsTrigger value="kanban">Kanban</TabsTrigger>
              <TabsTrigger value="list">List</TabsTrigger>
            </TabsList>
          </div>
          <TabsContent value="kanban" className="p-0">
            <KanbanBoard />
          </TabsContent>
          <TabsContent value="list" className="p-0">
            <TaskList />
          </TabsContent>
        </Tabs>
      </main>
    </div>
  )
}
